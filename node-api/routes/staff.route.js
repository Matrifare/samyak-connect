module.exports = app => {

    const staff = require("../controller/staff.controller.js");
    var router = require("express").Router();

    //get all approved staff
    router.get("/approved",staff.findAllApproved);
    //get all staff by query
    router.get("/query",staff.findByQuery);

    app.use('/api/staff', router);
};