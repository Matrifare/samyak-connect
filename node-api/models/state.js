const { Model } = require("sequelize");
const { DataTypes, sequelize} = require("sequelize");

module.exports = (sequelize) => {

    return sequelize.define("state",
    {
        state_id:{
            type: DataTypes.INTEGER,
            allowNull: false,
            primaryKey: true               
        },
        country_code:{
            type: DataTypes.STRING(3),
            allowNull: true
        },
        state_code:{
            type: DataTypes.STRING(25),
            allowNull: true
        },
        state_name:{
            type: DataTypes.STRING(255),
            allowNull: true
        },
        status:{
            type: DataTypes.STRING,
            allowNull: false
        }
    },
    {
        freezeTableName: true,
        timestamps: false,
    })

};