@foreach($data as $item)
    <li>
        <div class="faq-item">
            <div class="text">
                <div class="category">
                    <p>{{ $item->category->name }}</p>
                </div>
                <div class="question">
                    <p>{{ $item->question }}</p>
                </div>
                <div class="answer">
                    <p>{!! $item->answer !!}</p>
                </div>
            </div>
            <div class="control">
                <a href="{{ route('admin.faq.edit', $item) }}" class="main-btn yellow">edit</a>
            </div>
        </div>
    </li>
@endforeach