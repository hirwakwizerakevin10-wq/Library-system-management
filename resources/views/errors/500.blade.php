@include('errors.minimal', [
    'code' => '500',
    'title' => $title ?? 'Server error',
    'message' => $message ?? 'The application could not complete that request. Please try again.',
])
