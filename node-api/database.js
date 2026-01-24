const { Sequelize, DataTypes } = require("sequelize");
const epilogue = require("epilogue");
require('dotenv').config()
const dbconfig = require("./config/db.config.js");
const designationModel = require("./models/designation.js");
const countryModel = require("./models/country.js");
const stateModel = require("./models/state.js");
const occupationModel = require("./models/occupation.js");
const educationModel = require("./models/education_level.js");
const mothertongueModel = require("./models/mothertongue.js");
const religionModel = require("./models/religion.js");
const educationFieldModel = require("./models/education_field.js");
const educationDetailModel = require("./models/education_detail.js");
const staffModel = require("./models/staff.js");
const paymethodModel = require("./models/payment_method.js");
const loginlogsModel = require("./models/login_logs.js");
const registerModel = require("./models/register.js");
const registerViewModel = require("./models/register_view.js");
const cityModel = require("./models/city.js");
const smsTempModel = require("./models/sms_templete.js");
const emailTempModel = require("./models/email_templates.js");
const contactCheckerModel = require("./models/contact_checker.js");
const membershipPlanModel = require("./models/membership_plan.js");
const paymentsPlanModel = require("./models/payments.js");
const shortListModel = require("./models/short_list.js");
const casteModel = require("./models/caste.js");
const expressinterestModel = require("./models/expressinterest.js");
const blockProfileModel = require("./models/block_profile.js");
const expressinterestPModel = require("./models/expressinterestprivacy.js");
const messageModel = require("./models/message.js");
const descriptionApprovalsModel = require("./models/description_approvals.js");

const database = new Sequelize(dbconfig.DB, dbconfig.USER, dbconfig.PASSWORD, {
  host: dbconfig.HOST,
  dialect: dbconfig.dialect,
  operatorsAliases: false,

  pool: {
    max: dbconfig.pool.max,
    min: dbconfig.pool.min,
    acquire: dbconfig.pool.acquire,
    idle: dbconfig.pool.idle,
  },
});

const db = {};

const initializeDatabase = async (app) => {
  try {
    await database.authenticate();
    console.log("Connection has been established successfully.");

    db.Sequelize = Sequelize;
    db.sequelize = database;

    db.designations = designationModel(database);
    db.countries = countryModel(database);
    db.states = stateModel(database);
    db.occupations = occupationModel(database);
    db.education_levels = educationModel(database);
    db.mothertongues = mothertongueModel(database);
    db.religions = religionModel(database);
    db.educationFields = educationFieldModel(database);
    db.educationDetails = educationDetailModel(database);
    db.staffs = staffModel(database);
    db.paymentmethods = paymethodModel(database);
    db.loginlogs = loginlogsModel(database);
    db.registers = registerModel(database);
    db.registerViews = registerViewModel(database);
    db.cities = cityModel(database);
    db.smstemp = smsTempModel(database);
    db.emailtemp = emailTempModel(database);
    db.contactCheck = contactCheckerModel(database);
    db.membershipPlan = membershipPlanModel(database);
    db.payments = paymentsPlanModel(database);
    db.shortList = shortListModel(database);
    db.castes = casteModel(database);
    db.expressinterest = expressinterestModel(database);
    db.blockProfile = blockProfileModel(database);
    db.expressinterestprivacy = expressinterestPModel(database);
    db.message = messageModel(database);
    db.descriptionApprovals = descriptionApprovalsModel(database);

    return db;
  } catch (error) {
    console.error("Unable to connect to the database:", error);
  }
};

module.exports = { initializeDatabase, db };
