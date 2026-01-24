module.exports = app => {

    const paymentmethod = require("../controller/payment_method.controller.js");
    var router = require("express").Router();

    //get all approved religion
    router.get("/approved",paymentmethod.findAllApproved);
    //get all by query 
    router.get("/query",paymentmethod.findByQuery);

    app.use('/api/paymentmethod', router);
};