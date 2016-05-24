package de.lordvader.Heuanlage;

import java.sql.DriverManager;
import java.sql.SQLException;

/**
 * Created by Mika Mampe aka scheuerlappen on 24.05.2016.
 * Email: mikamampe@web.de
 * Feel free to ask questions.
 */
public class Lüftersteuerung {

    public static void main(String[] args) {
        public static String username;
        public static String passwort;
        public static String database;
        public static String host;
        public static String port;
        public static java.sql.Connection con;
        public static TimeManager plugin =  TimeManager.getInstance();


    public static void connect()
    {
        if (!isConnected()) {
            try {
                con = DriverManager.getConnection("jdbc:mysql://"+host+":"+port+"/"+database+"?autoReconnect=true&useUnicode=yes", username, passwort);
                Bukkit.getConsoleSender().sendMessage(plugin.getPrefix()+"MySQL Verbindung geöffnet!");
            } catch (SQLException e) {
                e.printStackTrace();
            }
        }




    }
    public static void close()
    {
        if (isConnected()) {
            try {
                con.close();
                Bukkit.getConsoleSender().sendMessage(plugin.getPrefix()+"MySQL Verbindung getrennt!");
            } catch (SQLException e) {
                e.printStackTrace();
            }
        }
    }


    public static boolean isConnected()
    {
        return con != null;
    }
    }
}
