module.exports = app => {

    const educationfield = require("../controller/education_field.controller.js");
    var router = require("express").Router();

    //get all approved education levels
    router.get("/approved",educationfield.findAllApproved);
    //get all by query
    router.get("/query",educationfield.findByQuery);

    app.use('/api/educationfield', router);
};