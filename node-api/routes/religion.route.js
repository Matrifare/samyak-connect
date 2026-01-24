module.exports = app => {

    const religion = require("../controller/religion.controller.js");
    var router = require("express").Router();

    //get all approved religion
    router.get("/approved",religion.findAllApproved);
    //get all religion by query
    router.get("/query",religion.findByQuery);

    app.use('/api/religion', router);
};