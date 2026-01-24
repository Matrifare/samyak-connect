module.exports = app => {
    const loginlog = require("../controller/login_logs.controller.js");
    var router = require("express").Router();

    //create login log
    router.post("/",loginlog.create);
    //get all by query
    router.get("/query", loginlog.findByQuery);

    app.use('/api/loginlogs', router);
};