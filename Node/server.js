const port = 7000;
const express = require('express');
const app = express();

// import router
const cardRouter = require('./card-route');
const transactionRouter = require('./transaction-route');

// routes for each services
app.use('/card', cardRouter);
app.use('/transaction', transactionRouter);

// listen to port
app.listen(port,function(){
    console.log("Successfully connected to server at localhost:" + port);
})