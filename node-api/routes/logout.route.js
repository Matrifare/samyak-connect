module.exports = app => {
    const logout = require("../controller/logout.controller.js"); 
    var router = require("express").Router();

    router.post("/", logout.logoutUser);

    app.use('/api/logout', router);
};