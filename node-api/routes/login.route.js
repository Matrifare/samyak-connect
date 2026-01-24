module.exports = app => {
    const login = require("../controller/login.controller.js");    
    var router = require("express").Router();

    // login
    router.post("/", login.authenticate);

    // reset password
    router.post("/resetPassword", login.resetPassword);

    app.use('/api/login', router);
};