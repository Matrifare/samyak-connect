const { DataTypes, sequelize } = require('sequelize');

module.exports = (sequelize) => {

    return sequelize.define("staff",
    {
        staff_id:{
            type: DataTypes.INTEGER,
            allowNull: false,
            primaryKey: true,               
        },
        status:{
            type: DataTypes.STRING,
            allowNull: false,
        },
        s_name:{
            type: DataTypes.STRING(250),
            allowNull: true,
        },
        s_email:{
            type: DataTypes.STRING(250),
            allowNull: true,
        },
        s_pass:{
            type: DataTypes.STRING(250),
            allowNull: true,
        },
        role:{
            type: DataTypes.INTEGER,
            allowNull: true,
        },
        mobile:{
            type: DataTypes.STRING(50),
            allowNull: true,
        },
        join_on:{
            type: DataTypes.DATE,
            allowNull: false,
        },
        credit:{
            type: DataTypes.STRING(50),
            allowNull: true,
        }
    },
    {
        freezeTableName: true,
        timestamps: false,
    });
};