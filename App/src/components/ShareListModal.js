import React, { useState } from 'react';

const ShareListModal = ({ users, onShare }) => {
    const [selectedUser, setSelectedUser] = useState('');
    const [permissions, setPermissions] = useState('view');

    const handleShare = () => {
        onShare(selectedUser, permissions);
    };

    return (
        <div>
            <h3>Share Task List</h3>
            <select onChange={(e) => setSelectedUser(e.target.value)} value={selectedUser}>
                <option value="">Select User</option>
                {users.map(user => (
                    <option key={user.username} value={user.username}>
                        {user.username}
                    </option>
                ))}
            </select>
            <select onChange={(e) => setPermissions(e.target.value)} value={permissions}>
                <option value="view">View Only</option>
                <option value="edit">Edit</option>
            </select>
            <button onClick={handleShare}>Share</button>
        </div>
    );
};

export default ShareListModal;
