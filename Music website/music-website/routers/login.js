const express = require('express');
const router = express.Router();
const User = require('../models/User');

// Route POST /api/login
router.post('/', async (req, res) => {
    const { email, password } = req.body;

    try {
        // Kiểm tra xem user có tồn tại trong database không
        let user = await User.findOne({ email });
        if (!user) {
            return res.status(400).json({ msg: 'Invalid Credentials' });
        }

        // Kiểm tra mật khẩu
        if (password !== user.password) {
            return res.status(400).json({ msg: 'Invalid Credentials' });
        }

        res.status(200).json({ msg: 'Login successful' });
    } catch (err) {
        console.error(err.message);
        res.status(500).send('Server Error');
    }
});

module.exports = router;
