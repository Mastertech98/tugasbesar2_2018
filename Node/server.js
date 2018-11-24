const port = 7000;
const express = require('express');
const app = express();

// import router
const cardRouter = require('./card-route');

// routes for each services
app.use('/card', cardRouter);

// listen to port 7000
app.listen(port)