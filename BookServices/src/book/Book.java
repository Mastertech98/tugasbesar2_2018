package book;

import java.util.ArrayList;
import java.util.List;

public class Book {
  private String id;
  private String title;
  private List<String> authors;
  private List<String> categories;
  private String cover;
  private String desc;
  private int harga;

  public Book(){
    id = "";
    title = "";
    authors = new ArrayList<String>();
    categories = new ArrayList<String>();
    cover = "";
    desc = "";
    harga = 0;
  }

  public Book(String tempid, String temptitle, List<String> tempauthors, List<String> tempcat, String tempcover, String tempdesc, int tempharga){
    id = tempid;
    title = temptitle;
    authors = tempauthors;
    categories = tempcat;
    cover = tempcover;
    desc = tempdesc;
    harga = tempharga;
  }

  public String getId() {
    return id;
  }

  public String getTitle() {
    return title;
  }

  public List<String> getAuthors() {
    return authors;
  }

  public List<String> getCategories() {
    return categories;
  }

  public String getCover() {
    return cover;
  }

  public String getDesc() {
    return desc;
  }

  public int getHarga() {
    return harga;
  }

  public void setId(String id) {
    this.id = id;
  }

  public void setTitle(String title) {
    this.title = title;
  }

  public void setAuthors(List<String> authors) {
    this.authors = authors;
  }

  public void setCover(String cover) {
    this.cover = cover;
  }

  public void setDesc(String desc) {
    this.desc = desc;
  }

  public void setHarga(int harga) {
    this.harga = harga;
  }

  public void setCategories(List<String> categories) {
    this.categories = categories;
  }

  @Override
  public String toString(){
    return ("id: "+ this.id + ", title: " + this.title + ", harga: " + this.harga);
  }
}
