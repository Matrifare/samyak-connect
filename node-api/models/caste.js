const { DataTypes, sequelize } = require('sequelize');

module.exports = (sequelize) => {

    return sequelize.define("caste",
    {    
      caste_id:{
        type: DataTypes.INTEGER,
        allowNull: false,
        primaryKey: true,    
      },
      religion_id:{
        type: DataTypes.INTEGER,
        allowNull: true
      },
      caste_name:{
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
      }
    )

};