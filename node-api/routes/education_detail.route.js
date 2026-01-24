module.exports = app => {

    const educationdetail = require("../controller/education_detail.controller.js");
    var router = require("express").Router();

    //get all approved education details
    router.get("/approved",educationdetail.findAllApproved);
    //get by query
    router.get("/query",educationdetail.findByQuery);

    app.use('/api/educationdetail', router);
};