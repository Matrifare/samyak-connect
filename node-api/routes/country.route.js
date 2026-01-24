module.exports = app => {

    const country = require("../controller/country.controller.js");
    var router = require("express").Router();

    //get all approved countries
    router.get("/approved",country.findAllApproved);
    //get all by query
    router.get("/query", country.findByQuery);

    app.use('/api/country', router);
};