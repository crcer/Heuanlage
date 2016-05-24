package de.lordvader.Heuanlage;

import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

/**
 * Created by Mika Mampe aka scheuerlappen on 24.05.2016.
 * Email: mikamampe@web.de
 * Feel free to ask questions.
 */
public class Lüftersteuerung {


    public static String username = "logger";
    public static String password = "Ci5hnkwV8";
    public static String database = "logger";
    public static String host = "localhost";
    public static String port = "3306";
    public static java.sql.Connection con;


    public static long seconds = 60L;

    public static String tableRoof = "roof";
    public static String tableOutside = "outside";

    public static void main(String[] args) {
        printconfig();
        connect();

        while (true)
        {
            if (isConnected())
            {
                getData();

                //logik
            }
            else
            {
                connect();
            }
            try {
                Thread.sleep(seconds*1000L);
            } catch (InterruptedException e) {
                e.printStackTrace();
            }
        }
    }



    public static MySQLResult getData()
    {
        MySQLResult result = new MySQLResult(0000, 0000, 0000, 0000);
        try {
            PreparedStatement psRoof = con.prepareStatement("SELECT * FROM roof ORDER BY datum DESC LIMIT 1");
            ResultSet rsRoof = psRoof.executeQuery();
            rsRoof.next();
            result.roofTemp = rsRoof.getDouble("temperatur");
            result.roofHum = rsRoof.getDouble("feuchtigkeit");

            PreparedStatement psOutside = con.prepareStatement("SELECT * FROM outside ORDER BY datum DESC LIMIT 1");
            ResultSet rsOutside = psRoof.executeQuery();
            rsOutside.next();
            result.outsideTemp = rsOutside.getDouble("temperatur");
            result.outsideHum = rsOutside.getDouble("feuchtigkeit");

        } catch (SQLException e) {
            e.printStackTrace();
        }
        return result;
    }





    public static void connect()
    {
        if (!isConnected()) {
            try {
                con = DriverManager.getConnection("jdbc:mysql://"+host+":"+port+"/"+database+"?autoReconnect=true&useUnicode=yes", username, password);
                System.out.println("MYSQL-Verbindung geöffnet!");
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
                System.out.println("MYSQL-Verbindung getrennt!");
            } catch (SQLException e) {
                e.printStackTrace();
            }
        }
    }


    public static boolean isConnected()
    {
        return con != null;
    }
    public static void printconfig()
    {
        System.out.println("========== Konfiguration ==========");
        System.out.println("Username: "+username);
        System.out.println("Password: ●●●●●●●●●●");
        System.out.println("Database: "+database);
        System.out.println("Host: "+host);
        System.out.println("Port: "+port);
        System.out.println("===================================");
    }
}
