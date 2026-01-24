module.exports = app => {

    const designation = require("../controller/designation.controller.js");
    var router = require("express").Router();

    //create designation
    router.post("/",designation.create);
    //get all approved designations
    router.get("/approved",designation.findAllApproved);
    //get all by query
    router.get("/query", designation.findByQuery);

    app.use('/api/designation', router);
};