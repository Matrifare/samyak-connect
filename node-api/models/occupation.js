const { DataTypes, sequelize } = require('sequelize');

module.exports = (sequelize) => {

    return sequelize.define("occupation",
    {
        ocp_id:{
            type: DataTypes.INTEGER,
            allowNull: false,
            primaryKey: true,               
        },
        ocp_name:{
            type: DataTypes.STRING(100),
            allowNull: true,
        },
        status:{
            type: DataTypes.STRING,
            allowNull: false,
        }
    },
    {
        freezeTableName: true,
        timestamps: false,
    });
};