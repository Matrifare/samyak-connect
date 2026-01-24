const { Model } = require("sequelize");
const { DataTypes, sequelize} = require("sequelize");

module.exports = (sequelize) => {

    return sequelize.define("email_templates",
    {
        EMAIL_TEMPLATE_ID:{
            type: DataTypes.INTEGER,
            allowNull: false,
            primaryKey: true               
        },
        EMAIL_TEMPLATE_NAME:{
            type: DataTypes.STRING,
            allowNull: true
        },
        PRE_CONDITION:{
            type: DataTypes.STRING,
            allowNull: true
        },
        EMAIL_SUBJECT:{
            type: DataTypes.STRING,
            allowNull: true
        },
        EMAIL_CONTENT:{
            type: DataTypes.STRING,
            allowNull: true
        },
        STATUS:{
            type: DataTypes.STRING,
            allowNull: false
        }
    },
    {
        freezeTableName: true,
        timestamps: false,
    })

};