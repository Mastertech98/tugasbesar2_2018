package example;

import book.*;
import javax.jws.WebMethod;
import javax.jws.WebService;
import javax.jws.soap.SOAPBinding;
import javax.ws.rs.client.Client;
import javax.ws.rs.client.ClientBuilder;
import javax.ws.rs.client.Entity;
import javax.ws.rs.client.WebTarget;
import javax.ws.rs.core.Form;
import javax.ws.rs.core.MediaType;
import javax.xml.ws.Endpoint;
import javax.xml.ws.Response;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.Random;

@WebService()
@SOAPBinding(style = SOAPBinding.Style.RPC)
public class HelloWorld {
  @WebMethod
  public Book[] searchBooksByTitle(String title){
    Books tempres = new Books(title, "intitle");
    ArrayList<Book> temp = tempres.getBooklist();
    Book[] result = new Book[temp.size()];
    try {
      Class.forName("com.mysql.jdbc.Driver");
      Connection myConn = DriverManager.getConnection("JDBC:mysql://localhost:3307/book_service", "root", "");
      Statement myStmt = myConn.createStatement();
      for (int i = 0; i<temp.size(); i++){
        result[i] = temp.get(i);
        String query = "SELECT price FROM prices WHERE book_id = '" + result[i].getId() + "';";
        ResultSet myRs = myStmt.executeQuery(query);
        while (myRs.next()) {
          int price = myRs.getInt("price");
          result[i].setHarga(price);
        }
        System.out.println(result[i]);
      }
    } catch (Exception e){
      e.printStackTrace();
    }
    return result;
  }

  @WebMethod
  public Book searchBookByID(String id){
    Books tempres = new Books(id);
    ArrayList<Book> temp = tempres.getBooklist();
    Book result = temp.get(0);
    try {
      Class.forName("com.mysql.jdbc.Driver");
      Connection myConn = DriverManager.getConnection("JDBC:mysql://localhost:3307/book_service", "root", "");
      Statement myStmt = myConn.createStatement();

      String query = "SELECT price FROM prices WHERE book_id = '" + result.getId() + "';";
      ResultSet myRs = myStmt.executeQuery(query);
      while (myRs.next()) {
        int price = myRs.getInt("price");
        result.setHarga(price);
      }
    } catch (Exception e){
      e.printStackTrace();
    }
    System.out.println(result.getCategories());
    return result;
  }

  @WebMethod
  public Book getRecommendation(String[] categories){
    try {
      Class.forName("com.mysql.jdbc.Driver");
      Connection myConn = DriverManager.getConnection("JDBC:mysql://localhost:3307/book_service", "root", "");
      Statement myStmt = myConn.createStatement();

      for(String cat : categories){
        String query = "SELECT book_id FROM total_bought WHERE category LIKE '%" + cat + "%' ORDER BY n_bought DESC;";
        ResultSet myRs = myStmt.executeQuery(query);
        if (myRs.next()) {
          String bookid = myRs.getString("book_id");
          System.out.println(bookid);
          Books tempres = new Books(bookid);
          ArrayList<Book> temp = tempres.getBooklist();
          Book result = temp.get(0);
          return result;
        }
      }
    } catch (Exception e){
      e.printStackTrace();
    }

    int rnd = new Random().nextInt(categories.length);
    String sub = categories[rnd];
    if (sub.equalsIgnoreCase("none")){
      return new Book();
    }
    Books tempres = new Books(sub, "subject");
    ArrayList<Book> temp = tempres.getBooklist();
    if (temp.size() > 0){
      rnd = new Random().nextInt(temp.size());
      return temp.get(rnd);
    } else {
      String[] arrtemp = sub.split(" ", 2);
      sub = arrtemp[0];
      tempres = new Books(sub, "subject");
      temp = tempres.getBooklist();
      if (temp.size() > 0) {
        rnd = new Random().nextInt(temp.size());
        return temp.get(rnd);
      }
      else{
        return new Book();
      }
    }
  }

  @WebMethod
  public boolean orderBook(int bookID, int bookCount, long accountNumber){
    try {
      Class.forName("com.mysql.jdbc.Driver");
      Connection myConn = DriverManager.getConnection("JDBC:mysql://localhost:3307/book_service", "root", "");
      Statement myStmt = myConn.createStatement();
      Client client= ClientBuilder.newClient();
      //WebTarget target = client.target("http://localhost:7000/transaction?sender="+ accountNumber + "&receiver=098778907654&amount=" + bookCount);
      WebTarget webTarget = client.target("http://localhost:7000/transaction?sender="+ accountNumber + "&receiver=098778907654&amount=" + bookCount);
      Form form = new Form();
      javax.ws.rs.core.Response response = webTarget.request().post(Entity.entity(form, MediaType.APPLICATION_FORM_URLENCODED));
      System.out.println(response);

    } catch (Exception e){
      e.printStackTrace();
    }
    return true;
  }

  public static void main(String[] argv) {
    Object implementor = new HelloWorld ();
    String address = "http://localhost:9000/HelloWorld";
    Endpoint.publish(address, implementor);
  }
}
