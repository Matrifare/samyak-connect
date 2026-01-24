const { DataTypes, sequelize } = require('sequelize')

module.exports = (sequelize) => {
    return sequelize.define("education_level",
        {
        e_level_id:{
            type: DataTypes.INTEGER,
            allowNull: false,
            primaryKey: true,
        },
        e_level_name:{
            type: DataTypes.STRING(50),
            allowNull: true,
        },
        status:{
            type: DataTypes.STRING(50),
            allowNull: false,
        }
        },
        {
        freezeTableName: true,
        timestamps: false,
    });
};