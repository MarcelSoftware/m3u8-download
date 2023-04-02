# m3u8 Downloader

This project can be used to download streams in m3u8 format.
These files can often be found in the network tab of your browser. 

## Usage

The file `cli.php` takes the m3u8 file as argument. This can be a link or a local file.

When the file is valid, the download is started.
The single parts are placed in a temporary directory called `files`
When the whole download is finished, the parts are merged in one file called `movie.ts`.
When everything was successful, the part folder will be deleted.

```bash
php cli.php "http://example.com/file.m3u8"
```
