package example;

import book.*;
import javax.jws.WebMethod;
import javax.jws.WebService;
import javax.jws.soap.SOAPBinding;
import javax.xml.ws.Endpoint;
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
    for (int i = 0; i<temp.size(); i++){
      result[i] = temp.get(i);
      System.out.println(result[i].getCategories());
    }
    return result;
  }

  @WebMethod
  public Book searchBookByID(String id){
    Books tempres = new Books(id);
    ArrayList<Book> temp = tempres.getBooklist();
    Book result = temp.get(0);
    System.out.println(result.getCategories());
    return result;
  }

  @WebMethod
  public Book getRecommendation(String[] categories){
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

  public static void main(String[] argv) {
    Object implementor = new HelloWorld ();
    String address = "http://localhost:9000/HelloWorld";
    Endpoint.publish(address, implementor);
  }
}
