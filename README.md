# PHP Queue Worker

Simple file-based queue worker in PHP.

## Features

- File based queue
- Worker processing loop
- Job retry mechanism
- Job id tracking
- Worker logging

## Example

```php
$queue->push(["type"=>"email"]);
```