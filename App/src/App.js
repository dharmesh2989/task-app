import React, { useState } from 'react';
import Auth from './components/Auth';
import TaskList from './components/TaskList';

const App = () => {
  const [user, setUser] = useState(JSON.parse(localStorage.getItem('user') || 'null'));
  const [tasks, setTasks] = useState([]);
  const [error, setError] = useState(null); // For handling errors

  const handleLogin = async (email, password) => {
    try {
      // Making the login API call
      const response = await fetch('http://127.0.0.1:8000/api/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ email, password }),
      });

      const data = await response.json();
      console.log("data", data);
      if (response.ok) {
        setUser(data.data.user);
        localStorage.setItem('token', data.data.token);
        localStorage.setItem('user', JSON.stringify(data.data.user))
      } else {
        // Handle login error (e.g., invalid credentials)
        setError(data.message || 'Login failed');
      }
    } catch (err) {
      // Catch any other errors like network issues
      setError('An error occurred while logging in');
    }
  };

  const handleRegister = async (username, email, password) => {
    try {
      // Making the register API call
      const response = await fetch('http://127.0.0.1:8000/api/register', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ username, email, password }),
      });

      const data = await response.json();

      if (response.ok) {
        setUser(null);
        // If registration is successful, set the user state
        // setUser({ username: data.username });
        // setUser(data.data.user);
        // localStorage.setItem('token', data.data.token);
        // localStorage.setItem('user', JSON.stringify(data.data.user))
      } else {
        // Handle registration error
        setError(data.message || 'Registration failed');
      }
    } catch (err) {
      // Catch any other errors like network issues
      setError('An error occurred while registering');
    }
  };

  const handleLogout = () => {
    localStorage.removeItem('user');
    localStorage.removeItem('token');
    setUser(null);
  };


  return (
    <div>
      {error && <div className="error">{error}</div>} {/* Display error message if any */}
      {user ? (
        <div>
          <h2>Welcome, {user.name}</h2>
          <button onClick={handleLogout}>Logout</button>
          <TaskList tasks={tasks} setTasks={setTasks} />
        </div>
      ) : (
        <Auth onLogin={handleLogin} onRegister={handleRegister} />
      )}
    </div>
  );
};

export default App;
