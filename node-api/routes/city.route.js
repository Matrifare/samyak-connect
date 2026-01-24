module.exports = app => {

    const city = require("../controller/city.controller.js");
    var router = require("express").Router();

    //create city
    router.post("/",city.create);
    //get all approved cities
    router.get("/approved",city.findAllApproved);
    //get all by query
    router.get("/query", city.findByQuery);

    app.use('/api/city', router);
};