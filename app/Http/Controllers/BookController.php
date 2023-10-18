<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Book;

class BookController extends Controller
{
    function index()
    {
        $entityManager = app('Doctrine\ORM\EntityManagerInterface');

        $booksAux = $entityManager->getRepository(Book::class)->findAll();

        return view("books.index", compact("booksAux"));
    }

    function store(Request $request)
    {
        $entityManager = app('Doctrine\ORM\EntityManagerInterface');

        $book = new Book();
        $book->setTitle($request->input("title"));
        $entityManager->persist($book);

        if ($entityManager->flush()) {
            return redirect()->route('books.index')->with('success', 'Libro creado con éxito');
        }
        return redirect()->route('books.index')->with('error', 'Libro no encontrado');
    }

    function edit($id)
    {
        $entityManager = app('Doctrine\ORM\EntityManagerInterface');
        $book = $entityManager->getRepository(Book::class)->find($id);

        if ($book) {
            return view("books.edit", compact("book"));
        }

        return redirect()->route('books.index')->with('error', 'Libro no encontrado');
    }

    function update(Request $request, $id)
    {
        $entityManager = app('Doctrine\ORM\EntityManagerInterface');
        $book = $entityManager->getRepository(Book::class)->find($id);

        if ($book) {
            $book->setTitle($request->input("title"));
            $entityManager->persist($book);
            $entityManager->flush();

            return redirect()->route('books.index')->with('success', 'Libro actualizado con éxito');
        }

        return redirect()->route('books.index')->with('error', 'Libro no encontrado');
    }

    function destroy($id)
    {
        $entityManager = app('Doctrine\ORM\EntityManagerInterface');

        $book = $entityManager->getRepository(Book::class)->find($id);

        if ($book) {
            $entityManager->remove($book);
            $entityManager->flush();

            return redirect("/books");
        }

        return redirect()->route('books.index')->with('error', 'Libro no encontrado');
    }
}
