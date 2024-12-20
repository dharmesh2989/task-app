<div class="table-responsive">
    <table class="table table-bordered">
        <tr>
            <th>{{ __('Name') }}</th>
            <td>{{ $user->name }}</td>
        </tr>
        <tr>
            <th>{{ __('Email') }}</th>
            <td>{{ $user->email }}</td>
        </tr>
        <tr>
            <th>{{ __('User Type') }}</th>
            <td>
                <span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-info-light text-info"> Users
                </span>
            </td>
        </tr>
        <tr>
            <th>{{ __('Status') }}</th>
            <td>
                @if ($user->status === 'active')
                <span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-success-light text-success"> Active
                </span>
                @else
                <span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-danger-light text-danger"> InActive
                </span>
                @endif
            </td>
        </tr>
    </table>
</div>
