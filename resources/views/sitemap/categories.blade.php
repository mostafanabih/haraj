<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($main_sections as $main)
        <url>
            <loc>{{ url('/menu/'. $main->name) }}</loc>
            <lastmod>{{ $main->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.6</priority>
        </url>
        @php $SubSection = \App\SubSection::select('id','name','updated_at')->where('main_id', $main->id)->get(); @endphp
       
            @if($SubSection)
                @foreach ($SubSection as $sub)
                   <url>
                    <loc>{{ url('/menu/'. $main->name.'?sub2='.$sub->id.'&name2='.$sub->name) }}</loc>
                    <lastmod>{{ $sub->updated_at->tz('UTC')->toAtomString() }}</lastmod>
                    <changefreq>weekly</changefreq>
                    <priority>0.6</priority>
                </url>
                 @endforeach
            @endif
    @endforeach
</urlset>