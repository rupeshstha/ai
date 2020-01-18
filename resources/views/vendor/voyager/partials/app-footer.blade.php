<footer class="app-footer">
    <div class="site-footer-right">
        {!! __('voyager::theme.footer_copyright') !!} <a href="https://bikramlama.com.np" target="_blank">Bikram Lama</a>
        @php $version = Voyager::getVersion(); @endphp
        @if (!empty($version))
            - {{ $version }}
        @endif
    </div>
</footer>
