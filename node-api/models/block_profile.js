const { DataTypes } = require('sequelize');

module.exports = (sequelize) => {
    return sequelize.define("block_profile_new",
    {    
      block_id:{
        type: DataTypes.INTEGER,
        allowNull: false,
        primaryKey: true,    
      },
      block_by:{
        type: DataTypes.STRING(250),
        allowNull: false
      },
      block_to:{
        type: DataTypes.STRING(250),
        allowNull: false
      },
      block_date:{
        type: DataTypes.DATE,
        allowNull: true
      },
    },
      {
        freezeTableName: true,
        timestamps: false,
      }
    )

};