module.exports = app => {

    const contactchecker = require("../controller/contact_checker.controller.js");
    var router = require("express").Router();

    //get all by my_id to check who viewed my profile
    router.get("/all", contactchecker.findByMyId);

    //create contact checker
    router.post("/create", contactchecker.createContactChecker);

    //check contact counts and payment plan
    router.get("/getContactCount", contactchecker.contactChecker);

    //check contact details already seen
    router.get("/seenContacts", contactchecker.getContacts);

    //check contact security
    router.get("/checkSecurity", contactchecker.contactSecurity);

    //seen contacts
    router.post("/seenContacts", contactchecker.seenContacts);

    //get contact views per day
    router.get("/contactViewsPerDay", contactchecker.contactViewsPerDay);

    //update contact checker
    router.put("/addContactChecker", contactchecker.updateContactChecker);

    app.use('/api/contact_checker', router);
};