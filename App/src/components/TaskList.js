import React, { useState, useEffect } from 'react';
import Task from './Task';

const TaskList = ({ tasks, setTasks }) => {
    const [newTask, setNewTask] = useState('');
    const [authToken] = useState(localStorage.getItem('token'));
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(null);

    useEffect(() => {
        fetchTasks();
    }, []);

    const fetchTasks = async () => {
        setLoading(true);
        setError(null);
        try {
            const response = await fetch('http://127.0.0.1:8000/api/task-lists', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${authToken}`,
                },
            });
            const data = await response.json();
            if (response.ok) {
                setTasks(data.data); // Assuming 'data.tasks' contains an array of tasks
            } else {
                setError('Failed to fetch tasks');
            }
        } catch (error) {
            setError('Error fetching tasks: ' + error.message);
        } finally {
            setLoading(false);
        }
    };

    // Add new task via API
    const addTask = async () => {
        if (newTask.trim()) {
            setLoading(true);
            setError(null);
            try {
                const response = await fetch('http://127.0.0.1:8000/api/task-lists', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${authToken}`,
                    },
                    body: JSON.stringify({ name: newTask, completed: false }),
                });

                const data = await response.json();
                if (response.ok) {
                    fetchTasks();
                    // Optimistically add the new task
                    // setTasks(prevTasks => [
                    //     ...prevTasks,
                    //     { id: data.task.id, name: data.task.name, completed: false }
                    // ]);
                } else {
                    setError('Failed to add task');
                }
            } catch (error) {
                setError('Error adding task: ' + error.message);
            } finally {
                setLoading(false);
            }
            setNewTask('');
        }
    };

    // Toggle task completion via API
    const toggleComplete = async (id) => {
        try {
            const taskToUpdate = tasks.find(task => task.id === id);
            const updatedTask = { ...taskToUpdate, completed: !taskToUpdate.completed };

            const response = await fetch(`http://127.0.0.1:8000/api/task-lists/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${authToken}`,
                },
                body: JSON.stringify(updatedTask),
            });

            const data = await response.json();
            if (response.ok) {
                setTasks(tasks.map(task =>
                    task.id === id ? { ...task, completed: !task.completed } : task
                ));
            } else {
                setError('Failed to update task');
            }
        } catch (error) {
            setError('Error toggling task completion: ' + error.message);
        }
    };

    // Delete task via API
    const deleteTask = async (id) => {
        try {
            const response = await fetch(`http://127.0.0.1:8000/api/task-lists/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${authToken}`,
                },
            });

            if (response.ok) {
                setTasks(tasks.filter(task => task.id !== id));
            } else {
                setError('Failed to delete task');
            }
        } catch (error) {
            setError('Error deleting task: ' + error.message);
        }
    };

    return (
        <div>
            <h3>Task List</h3>
            {loading && <p>Loading...</p>}
            {error && <p style={{ color: 'red' }}>{error}</p>}
            <input
                type="text"
                placeholder="New Task"
                value={newTask}
                onChange={(e) => setNewTask(e.target.value)}
            />
            <button onClick={addTask} disabled={loading}>
                {loading ? 'Adding...' : 'Add Task'}
            </button>
            <div>
                {tasks.map((task) => (
                    <Task
                        key={task.id}
                        task={task}
                        toggleComplete={toggleComplete}
                        deleteTask={deleteTask}
                    />
                ))}
            </div>
        </div>
    );
};

export default TaskList;
