package book.server;

import book.Books;

import javax.jws.WebService;

@WebService(endpointInterface = "book.server.BookSoap")
public class BookSoapImpl implements BookSoap{

  /*
    Fungsi isSoapServerWorking()
    hanya contoh,
    nanti dihapus aja
   */
  @Override
  public boolean isSoapServerWorking() {
    return true;
  }

  @Override
  public Books getBookList(String book_title) {
    return null;
  }

  @Override
  public Books getBookDetail(String book_id) {
    return null;
  }

  // lanjut implementasi fungsi yang bakal dicoba
}
