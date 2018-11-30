package server;

import book.Books;

import javax.jws.WebMethod;
import javax.jws.WebService;
import javax.jws.soap.SOAPBinding;

@WebService
@SOAPBinding(style = SOAPBinding.Style.RPC)
public interface BookSoap {
  @WebMethod boolean isSoapServerWorking();
  @WebMethod Books getBookList(String book_title);
  @WebMethod Books getBookDetail(String book_id);
//  @WebMethod <prototype fungsi yang bakal diakses>
//  lanjutin interface untuk fungsi yang bakal dipanggil
}
