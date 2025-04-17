const express = require('express');
const mongoose = require('mongoose');
const cors = require('cors');
require('dotenv').config();

const authRoutes = require('./routes/auth'); // make sure this file exists

const app = express(); // <-- YOU MISSED THIS

// Middleware
app.use(cors());
app.use(express.json());

// Connect to MongoDB
mongoose.connect('mongodb://localhost:27017/wedding-planner', {
  // useNewUrlParser and useUnifiedTopology are now deprecated
}).then(() => {
  console.log('MongoDB connected');
}).catch((err) => {
  console.error('MongoDB connection error:', err);
});

// Route for homepage (to avoid the "Cannot GET /" error)
app.get('/', (req, res) => {
  res.send('Welcome to the Wedding Planner API!');
});

// Auth routes
app.use('/api/auth', authRoutes);

// Start the server
const PORT = process.env.PORT || 5000;
app.listen(PORT, () => {
  console.log(`Server started on http://localhost:${PORT}`);
});
