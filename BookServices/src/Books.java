import com.google.gson.JsonArray;
import com.google.gson.JsonElement;
import com.google.gson.JsonObject;
import com.google.gson.JsonParser;

import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.ArrayList;

public class Books {
  private ArrayList<Book> booklist =  new ArrayList<Book>();
  public static String key = "AIzaSyBvlZ10cXAs93BbX-F5ZnYaWnzKhFPTGcU";

  public Books(String title){
    title = title.replace(" ", "+");
    String link = "https://www.googleapis.com/books/v1/volumes?q=intitle:" + title + "&maxResults=20&filter=partial&key=" + key;
    try {
      String response = getResponse(link);

      JsonParser jsonParser = new JsonParser();
      JsonObject jo = (JsonObject)jsonParser.parse(response.toString());

      int n_items = jo.get("totalItems").getAsInt();
      if (n_items > 20){
        n_items = 20;
      }
      for (int i = 0; i < n_items; i++){
        JsonObject temp = jo.getAsJsonArray("items").get(i).getAsJsonObject();
        String id = temp.get("id").getAsString();
        String booktitle = temp.get("volumeInfo").getAsJsonObject().get("title").getAsString();
        ArrayList<String> authors = new ArrayList<String>();
        try {
          JsonArray response_authors = temp.get("volumeInfo").getAsJsonObject().getAsJsonArray("authors");
          for (JsonElement author : response_authors) {
            authors.add(author.getAsString());
          }
        }
        catch (NullPointerException e){
          authors.add("Anonymous");
        }
        String cover = temp.get("volumeInfo").getAsJsonObject().get("imageLinks").getAsJsonObject().get("thumbnail").getAsString();
        String desc;
        try {
          desc = temp.get("volumeInfo").getAsJsonObject().get("description").getAsString();
        }
        catch(NullPointerException e){
          desc = "none";
        }
        int harga = 0;
        if (!temp.get("saleInfo").getAsJsonObject().get("saleability").getAsString().equals("NOT_FOR_SALE")) {
          harga = temp.get("saleInfo").getAsJsonObject().get("listPrice").getAsJsonObject().get("amount").getAsInt();
        }
        else {
          harga = -999;
        }
        Book tempbook = new Book(id, booktitle, authors, cover, desc, harga);
        booklist.add(tempbook);
        System.out.println(tempbook);
      }

    } catch (Exception e) {
      e.printStackTrace();
    }
  }

  public String getResponse(String link){
    HttpURLConnection connection = null;
    try {
      URL address = new URL(link);
      connection = (HttpURLConnection) address.openConnection();
      connection.setRequestMethod("GET");
      connection.setReadTimeout(5000);
      connection.setConnectTimeout(5000);

      BufferedReader in = new BufferedReader(
              new InputStreamReader(connection.getInputStream()));
      int input;
      StringBuilder response = new StringBuilder();

      while ((input = in.read()) != -1) {
        response.append((char) input);
      }
      in.close();
      return response.toString();
    }
    catch (Exception e) {
      e.printStackTrace();
      return "Error";
    }
  }

  @Override
  public String toString(){
    StringBuilder result = new StringBuilder();
    for (Book book: booklist){
      result.append(book.toString());
    }
    return result.toString();
  }

  public static void main(String[] argv) {
    Books hello = new Books("harry potter");
  }
}
