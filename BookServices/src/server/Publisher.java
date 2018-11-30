package server;

import javax.xml.ws.Endpoint;

public class Publisher {
  public static void main(String[] args) {
    Object implementor = new BookSoapImpl();
    String address = "http://localhost:9000/book";
    Endpoint.publish(address, implementor);
  }
}
