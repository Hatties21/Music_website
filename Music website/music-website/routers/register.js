const express = require('express');
const router = express.Router();
const User = require('../models/User');

// Route POST /api/register
router.post('/', async (req, res) => {
    const { username, email, password } = req.body;

    try {
        // Kiểm tra xem email đã tồn tại trong database chưa
        let user = await User.findOne({ email });
        if (user) {
            return res.status(400).json({ msg: 'Email already exists' });
        }

        // Tạo một user mới
        user = new User({
            username,
            email,
            password
        });

        // Lưu user vào MongoDB
        await user.save();

        res.status(200).json({ msg: 'User registered successfully' });
    } catch (err) {
        console.error(err.message);
        res.status(500).send('Server Error');
    }
});

module.exports = router;
