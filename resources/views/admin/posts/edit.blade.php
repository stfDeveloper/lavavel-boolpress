@extends('layouts.app')

<div class="containerCrea">
<form action="{{route('admin.posts.update', $post->id)}}" method="post">
@csrf
@method('PUT')
    <div class="form-group">
        <input type="text" id="inputTitle" name="title" placeholder="Nuovo titolo" value="{{$post->title}}">
    </div>
    <div class="form-group">
        <textarea name="content" id="inputContent">{{$post->content}}</textarea>
    </div>
    <div class="form-group">
        <select name="category_id" id="">
            <option value="">----</option>
            @foreach ($categories as $element)
            <option value="{{$element->id}}">{{$element->type}}</option>
            @endforeach
        </select>
    </div> 

    <div class="form-group">
        <label for="tags">
         Tags:
        </label>
        @foreach ($tags as $tag)
        <div class="form-check">
            <input type="checkbox" name="tags[]" class="form-check-input" value="{{$tag->id}}" id="{{$tag->slug}}" {{$post->tags->contains($tag)? 'checked': ''}}>
            <label for="{{$tag->slug}}" class="form-check-label">
                {{$tag->name}}
            </label>
        </div>
        @endforeach
    </div>


    <button type="submit">Salva</button>
    <a href="{{route("admin.posts.index")}}"><button type="button">back</button></a>
    </div>
</form>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

