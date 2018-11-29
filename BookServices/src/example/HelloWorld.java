package example;

import book.*;
import javax.jws.WebMethod;
import javax.jws.WebService;
import javax.jws.soap.SOAPBinding;
import javax.xml.ws.Endpoint;
import java.util.ArrayList;

@WebService()
@SOAPBinding(style = SOAPBinding.Style.RPC)
public class HelloWorld {
  @WebMethod
  public String sayHelloWorldFrom(String from) {
    String result = "Hello, world, from " + from;
    System.out.println(result);
    return result;
  }

  @WebMethod
  public Book[] searchBooksByTitle(String title){
    Books tempres = new Books(title, "intitle");
    ArrayList<Book> temp = tempres.getBooklist();
    Book[] result = new Book[temp.size()];
    for (int i = 0; i<temp.size(); i++){
      result[i] = temp.get(i);
    }
    return result;
  }

  public static void main(String[] argv) {
    Object implementor = new HelloWorld ();
    String address = "http://localhost:9000/HelloWorld";
    Endpoint.publish(address, implementor);
  }
}
