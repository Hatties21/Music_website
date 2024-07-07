const express = require('express');
const mongoose = require('mongoose');
const bodyParser = require('body-parser');
const path = require('path');
const loginRoutes = require('./routes/login');
const registerRoutes = require('./routes/register');

const app = express();

app.use(bodyParser.json());
app.use(express.static(path.join(__dirname, 'public')));

// Kết nối tới MongoDB
mongoose.connect('mongodb://localhost:27017/music-website', {
    useNewUrlParser: true,
    useUnifiedTopology: true,
})
.then(() => console.log('MongoDB connected'))
.catch(err => console.log('MongoDB connection error:', err));

// Sử dụng các routes
app.use('/api/login', loginRoutes);
app.use('/api/register', registerRoutes);

const PORT = process.env.PORT || 5000;
app.listen(PORT, () => {
    console.log(`Server running on port ${PORT}`);
});
