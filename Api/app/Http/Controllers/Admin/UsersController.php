<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Notify;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use App\Models\User;
use Yajra\DataTables\DataTables;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    protected $authLayout = '';
    protected $pageLayout = '';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authLayout = 'admin.auth.';
        $this->pageLayout = 'admin.pages.user.';
        $this->middleware('Admin');
    }

    /* -----------------------------------------------------------------------------------------
    @Description: Function Index Page
    -------------------------------------------------------------------------------------------- */

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::where('user_type', 'user')->orderBy('updated_at', 'desc');
            return DataTables::of($users)->addIndexColumn()
                ->addColumn('user_type', function ($row) {
                    return '<span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-info-light text-info">Users</span>';
                })
                ->addColumn('avatar', function ($row) {
                    if (!$row->avatar) {
                        return '<img class="img-thumbnail" src="' . asset('storage/user/user.png') . '" width="50px" height="50px">';
                    } else {
                        return '<img class="img-thumbnail" src="' . asset('storage/user' . '/' . $row->avatar) . '" width="50px" height="50px">';
                    }
                })
                ->addColumn('status', function ($row) {
                    if ($row->status === 'active') {
                        return '<a href="javascript:void(0)" data-toggle="tooltip" title="Active" class="statusUser" data-id="' . $row->id . '"><span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-success-light text-success">Active</span></a>';
                    } else {
                        return '<a href="javascript:void(0)" data-toggle="tooltip" title="InActive" class="statusUser" data-id="' . $row->id . '"><span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-danger-light text-danger">InActive</span></a>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $action  = '';
                    $action .= '<a href=' . route('admin.user.edit', [$row->id]) . ' class="btn btn-sm btn-warning me-1 mb-3" data-toggle="tooltip" title="Edit"><i class="fa fa-fw fa-pencil me-1"></i> Edit</a>';
                    $action .= '<a href="javascript:void(0)" class="btn btn-sm btn-danger me-1 mb-3 deleteUser" data-id ="' . $row->id . '" data-toggle="tooltip" title="Delete"><i class="fa fa-fw fa-trash me-1"></i> Delete</a>';
                    $action .= '<a href="javascript:void(0)" class="btn btn-sm btn-info me-1 mb-3 viewUser" data-id ="' . $row->id . '" data-toggle="tooltip" title="View"><i class="fa fa-fw fa-eye me-1"></i> View</a>';
                    return $action;
                })->filter(function ($instance) use ($request) {
                    if (!empty($request->get('id'))) {
                        $instance->where('id', $request->get('id'));
                    }
                    if (!empty($request->get('name'))) {
                        $instance->where('name', $request->get('name'));
                    }
                    if (!empty($request->get('email'))) {
                        $instance->where('email', $request->get('email'));
                    }
                    if (!empty($request->get('user_type'))) {
                        $instance->where('user_type', $request->get('user_type'));
                    }
                    if (!empty($request->get('status'))) {
                        $instance->where('status', $request->get('status'));
                    }

                    if (!empty($request->get('search'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->get('search');
                            $w->orWhere('id', 'LIKE', "%$search%")
                                ->orWhere('email', 'LIKE', "%$search%")
                                ->orWhere('name', 'LIKE', "%$search%")
                                ->orWhere('user_type', 'LIKE', "%$search%")
                                ->orWhere('status', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['action', 'user_type', 'status', 'avatar'])
                ->make(true);
        }
        return view($this->pageLayout . 'index');
    }

    /*-----------------------------------------------------------------------------------
    @Description: Function for create User
    ---------------------------------------------------------------------------------- */
    public function create(Request $request)
    {
        try {
            return view($this->pageLayout . 'create');
        } catch (Exception $e) {
            smilify('error', $e->getMessage());
            return back()->with(['alert-type' => 'danger', 'message' => $e->getMessage()]);
        }
    }

    /*-----------------------------------------------------------------------------------
    @Description: Function for Update User
    ---------------------------------------------------------------------------------- */
    public function store(Request $request)
    {
        $customMessages = [
            'name.required'  => 'Name is Required',
            'email.required' => 'Email is Required',
            'password.required'              => 'The new password field is required.',
            'password_confirmation.required' => 'The confirm password field is required.'
        ];
        $validatedData = Validator::make($request->all(), [
            'name'  => 'required',
            'email' => 'required',
            'password'              => 'required|min:8',
            'password_confirmation' => 'required|min:8',
        ], $customMessages);
        $validatedData->after(function () use ($validatedData, $request) {
            if ($request->get('password') !== $request->get('password_confirmation')) {
                $validatedData->errors()->add('password_confirmation', 'The Confirm Password does not match.');
            }
        });
        if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }
        try {
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $extension = $file->getClientOriginalExtension();
                $filename = Str::random(10) . '.' . $extension;
                Storage::disk('public')->putFileAs('user', $file, $filename);
            } else {
                $filename = 'user.png';
            }
            User::create([
                'avatar'   => @$filename,
                'name'     => @$request->get('name'),
                'email'    => @$request->get('email'),
                'password' => Hash::make($request->get('password')),
            ]);
            smilify('success', 'Users Created Successfully 🔥');
            return redirect()->route('admin.user.index');
        } catch (Exception $e) {
            smilify('error', $e->getMessage());
            return back()->with(['alert-type' => 'danger', 'message' => $e->getMessage()]);
        }
    }

    /*-----------------------------------------------------------------------------------
    @Description: Function for Edit User
    ---------------------------------------------------------------------------------- */
    public function edit($id)
    {
        try {
            $user = User::where('id', $id)->first();
            if (!empty($user)) {
                return view($this->pageLayout . 'edit', compact('user'));
            } else {
                smilify('error', 'Users Id Invalid 🔥');
                return redirect()->route('admin.user.index');
            }
        } catch (Exception $e) {
            smilify('error', $e->getMessage());
            return back()->with(['alert-type' => 'danger', 'message' => $e->getMessage()]);
        }
    }

    /*-----------------------------------------------------------------------------------
    @Description: Function for Update User
    ---------------------------------------------------------------------------------- */
    public function update(Request $request, $id)
    {
        $customMessages = [
            'name.required'  => 'Name is Required',
            'email.required' => 'Email is Required',
        ];
        $validatedData = Validator::make($request->all(), [
            'name'  => 'required',
            'email' => 'required',
        ], $customMessages);
        if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }
        try {
            $oldDetails = User::find($id);
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $extension = $file->getClientOriginalExtension();
                $filename = Str::random(10) . '.' . $extension;
                Storage::disk('public')->putFileAs('user', $file, $filename);
            } else {
                if ($oldDetails->avatar !== null) {
                    $filename = $oldDetails->avatar;
                } else {
                    $filename = 'user.png';
                }
            }
            User::where('id', $id)->update([
                'avatar' => @$filename,
                'name'   => @$request->get('name'),
                'email'  => @$request->get('email'),
            ]);
            smilify('success', 'Users Updated Successfully 🔥');
            return redirect()->route('admin.user.index');
        } catch (Exception $e) {
            smilify('error', $e->getMessage());
            return back()->with(['alert-type' => 'danger', 'message' => $e->getMessage()]);
        }
    }

    /*-----------------------------------------------------------------------------------
    @Description: Function for Delete User
    ------------------------------------------------------------------------------------*/
    public function delete($id)
    {
        try {
            $user = User::where('id', $id)->first();
            $user->delete();
            smilify('success', 'Users Delete Successfully 🔥');
            return response()->json(['status' => 'success', 'title' => 'Success!!', 'message' => 'Category Deleted Successfully..!']);
        } catch (\Exception $e) {
            smilify('error', $e->getMessage());
            return back()->with(['alert-type' => 'danger', 'message' => $e->getMessage()]);
        }
    }

    /*-----------------------------------------------------------------------------------
    @Description: Function for Show User
    ------------------------------------------------------------------------------------*/
    public function show(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        return view($this->pageLayout . 'show', compact('user'));
    }

    /*-----------------------------------------------------------------------------------
    @Description: Function for Change Status User
    ------------------------------------------------------------------------------------*/
    public function changeStatus(Request $request)
    {
        try {
            $user = User::where('id', $request->id)->first();
            if ($user->status == "active") {
                User::where('id', $request->id)->update(['status' => "inactive"]);
            } else {
                User::where('id', $request->id)->update(['status' => "active"]);
            }
            smilify('success', 'User Status Updated Successfully 🔥 !');
            return response()->json(['status' => 'success', 'title' => 'Success!!', 'message' => 'User Status Updated Successfully..!']);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'title' => 'Error!!', 'message' => $e->getMessage()]);
        }
    }

    /*-----------------------------------------------------------------------------------
    @Description: Function for Get profile details
    ---------------------------------------------------------------------------------- */
    public function updateProfile()
    {
        $user = User::where(['status' => 'active', 'id' => Auth::user()->id])->first();
        if (empty($user)) {
            smilify('error', 'Invalid credentials 🔥');
            return redirect()->route('admin.dashboard');
        }
        // dd($user);
        return view($this->pageLayout . 'updateprofile', compact('user'));
    }

    /*-----------------------------------------------------------------------------------
    @Description: Function for Update profile details
    ---------------------------------------------------------------------------------- */
    public function updateProfileDetail(Request $request)
    {
        $customMessages = [
            'name.required'   => 'Name is Required',
            'email.required'  => 'Email is Required',
            'avatar.required' => 'Avatar is Required',
        ];
        $validatedData = Validator::make($request->all(), [
            'name'   => 'required',
            'email'  => 'required|unique:users,email,' . Auth::user()->id,
            'avatar' => 'sometimes|mimes:jpeg,jpg,png'
        ], $customMessages);
        if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }
        try {
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $extension = $file->getClientOriginalExtension();
                $filename = Str::random(10) . '.' . $extension;
                Storage::disk('public')->putFileAs('user', $file, $filename);
            } else {
                $userDetail = User::where('id', Auth::user()->id)->first()->avatar;
                $filename = $userDetail;
            }
            User::where('id', Auth::user()->id)->update([
                'email'          => $request->email,
                'name'          => $request->name,
                'avatar'         => $filename,
            ]);
            smilify('success', 'User Profile Update Successfully 🔥 !');
            return redirect()->back();
        } catch (Exception $e) {
            smilify('error', $e->getMessage());
            return back()->with(['alert-type' => 'danger', 'message' => $e->getMessage()]);
        }
    }

    /*-----------------------------------------------------------------------------------
    @Description: Function for update Password
    ---------------------------------------------------------------------------------- */
    public function updatePassword(Request $request)
    {
        try {
            $validatedData = Validator::make($request->all(), [
                'old_password'          => 'required',
                'password'              => 'required|min:6',
                'password_confirmation' => 'required|min:6',
            ], [
                'old_password.required'          => 'The current password field is required.',
                'password.required'              => 'The new password field is required.',
                'password_confirmation.required' => 'The confirm password field is required.'
            ]);
            $validatedData->after(function () use ($validatedData, $request) {
                if ($request->get('password') !== $request->get('password_confirmation')) {
                    $validatedData->errors()->add('password_confirmation', 'The Confirm Password does not match.');
                }
            });
            if ($validatedData->fails()) {
                return redirect()->back()->withErrors($validatedData)->withInput();
            }
            if (Hash::check($request->get('old_password'), auth()->user()->password) === false) {
                return redirect()->back();
            }
            $user = auth()->user();
            $user->password = Hash::make($request->get('password'));
            $user->save();
            smilify('success', 'User Password Update Successfully 🔥 !');
            return redirect()->back();
        } catch (Exception $e) {
            smilify('error', $e->getMessage());
            return back()->with(['alert-type' => 'danger', 'message' => $e->getMessage()]);
        }
    }
}
