const { DataTypes, sequelize } = require('sequelize');

module.exports = (sequelize) => {

    return sequelize.define("shortlist",
    {    
      sh_id:{
        type: DataTypes.INTEGER,
        allowNull: false,
        primaryKey: true,    
      },
      from_id:{
        type: DataTypes.TEXT(50),
        allowNull: false
      },
      to_id:{
        type: DataTypes.TEXT(50),
        allowNull: false
      },
      add_date:{
        type: DataTypes.DATE,
        allowNull: true,
      },
    },
      {
        freezeTableName: true,
        timestamps: false,
      }
    )

};