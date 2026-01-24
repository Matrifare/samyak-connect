module.exports = app => {

    const state = require("../controller/state.controller.js");
    var router = require("express").Router();

    //get all approved states
    router.get("/approved",state.findAllApproved);
    //get all approved by country id
    router.get("/country",state.findAllByCountry);
    //get all by query
    router.get("/query",state.findByQuery);

    app.use('/api/state', router);
};