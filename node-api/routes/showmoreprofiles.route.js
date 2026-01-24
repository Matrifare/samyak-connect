module.exports = app => {

    const showmoreprofiles = require("../controller/showmoreprofiles.controller.js");
    var router = require("express").Router();

    //get bookmark
    router.get("/bookmark", showmoreprofiles.bookmark);

    //add bookmark
    router.post("/addBookmark", showmoreprofiles.addBookmark);

    //remove bookmark
    router.delete("/deleteBookmark", showmoreprofiles.removeBookmark);

    //get recent premium
    router.get("/recentpremium", showmoreprofiles.recentpremium);

    //get recent
    router.get("/recent", showmoreprofiles.recent);

    //get Short Listed Profiles By Me
    router.get("/shortlisted",showmoreprofiles.shortlisted);

    //get visitor List of My Profile - who viewed my profile
    router.get("/viewed",showmoreprofiles.viewed);

    //get profiles visited by me
    router.get("/visitor",showmoreprofiles.visitor);

    //get Block Listed Profiles By Me
    router.get("/block",showmoreprofiles.block);

    //get Contact Details of profiles viewed by me
    router.get("/viewedcontacts",showmoreprofiles.viewedcontacts);

    //get Who Viewed my Contact Details
    router.get("/viewedmycontacts",showmoreprofiles.viewedmycontacts);

    //get suspended profile
    router.get("/suspendedprofie",showmoreprofiles.profilesuspended);

    //get success story
    router.get("/success_story",showmoreprofiles.viewsuccess_story);

    //get featured profiles
    router.get("/featuredprofiles",showmoreprofiles.featuredprofiles);

    //get profile views per day
    router.get("/profileviewsperday", showmoreprofiles.profileViewsPerDay);

    router.post("/addWhoViewedMyProfile", showmoreprofiles.addWhoViewedMyProfile);

    app.use('/api/showmoreprofiles', router);
};