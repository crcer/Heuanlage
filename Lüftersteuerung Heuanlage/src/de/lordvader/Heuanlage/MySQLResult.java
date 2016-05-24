package de.lordvader.Heuanlage;

/**
 * Created by Mika Mampe aka scheuerlappen on 24.05.2016.
 * Email: mikamampe@web.de
 * Feel free to ask questions.
 */
public class MySQLResult {

    public double outsideTemp;
    public double outsideHum;
    public double roofTemp;
    public double roofHum;


    public MySQLResult(double outsideTemp, double outsideHum, double roofTemp, double roofHum) {
        this.outsideTemp = outsideTemp;
        this.outsideHum = outsideHum;
        this.roofTemp = roofTemp;
        this.roofHum = roofHum;
    }
}
