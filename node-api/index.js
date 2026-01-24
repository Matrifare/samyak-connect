const express = require("express");
const bodyParser = require("body-parser");
const { promisify } = require("util");
const { initializeDatabase, db } = require("./database");
var session = require("express-session");
var cors = require("cors");
const multer = require("multer");
const upload = multer();
const app = express();
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));
app.use(upload.single("image"));
app.use(
  cors({
    origin: [
      "https://app.samyakmatrimony.com",
      "http://localhost:3001",
      "http://localhost:5173", // Vite default port
      "http://localhost:3000", // Common alternative port
    ], // allow these origins to access your API
    methods: "GET,HEAD,PUT,PATCH,POST,DELETE", // allowed methods
    credentials: true, // include cookies in requests
  })
);

const fs = require("fs");
const path = require("path");

const startServer = async () => {
  await initializeDatabase(app);

  // Set up session middleware before routes
  app.use(
    session({
      name: "qid",
      cookie: {
        maxAge: 60 * 60 * 24 * 30, // 1 month
        httpOnly: true,
        sameSite: "lax",
      },
      saveUninitialized: true,
      resave: false, // Add this to fix deprecation warning
      secret: "veryimportantsecret",
    })
  );

  require("./routes/designation.route")(app);
  require("./routes/country.route")(app);
  require("./routes/state.route")(app);
  require("./routes/occupation.route")(app);
  require("./routes/education_level.route")(app);
  require("./routes/mothertongue.route")(app);
  require("./routes/religion.route")(app);
  require("./routes/education_field.route")(app);
  require("./routes/education_detail.route")(app);
  require("./routes/staff.route")(app);
  require("./routes/payment_method.route")(app);
  require("./routes/payments.route")(app);
  require("./routes/login_logs.route")(app);
  require("./routes/register.route")(app);
  require("./routes/login.route")(app);
  require("./routes/logout.route")(app);
  require("./routes/city.route")(app);
  require("./routes/sms_templete.route")(app);
  require("./routes/email_templates.route")(app);
  require("./routes/sms_utils.route")(app);
  require("./routes/validations.route")(app);
  require("./routes/contact_checker.route")(app);
  require("./routes/membership_plan.route")(app);
  require("./routes/showmoreprofiles.route")(app);
  require("./routes/cast.route")(app);
  require("./routes/expressinterest.route")(app);
  require("./routes/block_profile.route")(app);
  require("./routes/expressinterestprivacy.route")(app);
  require("./routes/message.route")(app);
  require("./routes/photo_upload.route")(app);
  require("./routes/description_approvals.route")(app);
  require("./routes/stats.route")(app);
  require("dotenv").config();

  const port = process.env.SERVER_PORT || 3006;
  await promisify(app.listen).bind(app)(port);
  console.log(`Listening on port ${port}`);
};

// middleware to validate user session
app.use((req, res, next) => {
  next();
  // if (req.path !== '/api/register') {
  //   next();
  // } else {
  //   if (req.session.userId) {
  //     next();
  //   } else {
  //     res.status(403).send({
  //       message: "forbidden"
  //     });
  //   }
  // }
});

// Request logger middleware
app.use((req, res, next) => {
  const logMsg = `[${new Date().toISOString()}] ${req.method} ${
    req.originalUrl
  }\n`;
  console.log(logMsg.trim());
  try {
    const logDir = path.join(__dirname, "logs");
    const logFile = path.join(
      logDir,
      `${new Date().toISOString().slice(0, 10)}.log`
    );
    fs.appendFileSync(logFile, logMsg);
  } catch (err) {
    console.error("Error writing to log file:", err);
  }
  next();
});

startServer();
