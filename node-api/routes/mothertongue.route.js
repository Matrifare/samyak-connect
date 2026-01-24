module.exports = app => {

    const mothertongue = require("../controller/mothertongue.controller.js");
    var router = require("express").Router();

    //get all approved mothertongues
    router.get("/approved",mothertongue.findAllApproved);
    //get all mothertongue by query
    router.get("/query",mothertongue.findByQuery);

    app.use('/api/mothertongue', router);
};