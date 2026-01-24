module.exports = app => {

    const occupation = require("../controller/occupation.controller.js");
    var router = require("express").Router();

    //get all approved occupations
    router.get("/approved",occupation.findAllApproved);
    //get all occupation by query
    router.get("/query",occupation.findByQuery);

    app.use('/api/occupation', router);
};