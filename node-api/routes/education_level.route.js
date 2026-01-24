module.exports = app => {

    const educationlevel = require("../controller/education_level.controller.js");
    var router = require("express").Router();

    //get all approved education levels
    router.get("/approved",educationlevel.findAllApproved);
    //get all education level by query
    router.get("/query",educationlevel.findByQuery);

    app.use('/api/educationlevel', router);
};