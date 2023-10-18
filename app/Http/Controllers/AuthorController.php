<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Author;
use DateTime;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    function index()
    {
        $entityManager = app('Doctrine\ORM\EntityManagerInterface');

        $authors = $entityManager->getRepository(Author::class)->findAll();

        return view("authors.index", compact("authors"));
    }

    function store(Request $request)
    {

        $rules = [
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:0|max:100',
            'birthdate' => 'required|date',
        ];

        $messages = [
            'name.required' => 'El campo Nombre es obligatorio.',
            'age.required' => 'El campo Edad es obligatorio.',
            'birthdate.required' => 'El campo Fecha de Nacimiento es obligatorio.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);


        if ($validator->fails()) {
            return redirect()
                ->route('authors.index')
                ->withErrors($validator)
                ->withInput();
        }

        $entityManager = app('Doctrine\ORM\EntityManagerInterface');

        $author = new Author();
        $author->setName($request->input("name"));
        $author->setAge($request->input("age"));
        $birthdateInput = $request->input('birthdate'); 
        $birthdate = DateTime::createFromFormat('Y-m-d', $birthdateInput);
        $author->setBirthdate($birthdate); 
        $entityManager->persist($author);

        if ($entityManager->flush()) {
            return redirect()->route('authors.index')->with('success', 'Autor creado con éxito');
        }
        return redirect()->route('authors.index')->with('error', 'Autor no encontrado');
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
