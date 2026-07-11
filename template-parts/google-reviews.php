<?php
/**
 * Template part: Google Reviews section.
 *
 * Reviews are hardcoded for simplicity and performance — no API key needed.
 * Edit the $reviews array below to update the displayed reviews.
 * Link points to the Google share page for BM Fitness.
 *
 * @package BMFitness
 */

$google_reviews_url = 'https://share.google/qwBx3zC14JDmRd46g';

// Add your actual Google reviews here.
$reviews = array(
	array(
		'author' => 'Erik M.',
		'rating' => 5,
		'text'   => 'Izrazito moderna i suvremena teretana opremljena mnoštvom kvalitetnih sprava i pomagala za razne tipove vježbanja. Prostor je izrazito uredan i čist te klimatiziran, a atmosfera je ugodna i motivirajuća. Osoblje vrlo uljudno, ažurno i prijateljski nastrojeno. Sve preporuke!',
		'date'   => 'Prije 4 mjesca',
	),
	array(
		'author' => 'Tea B. S.',
		'rating' => 5,
		'text'   => 'BM Fitness prostor je moderan, čist i opremljen vrhunskim spravama za svaki tip vježbanja. Osoblje je uvijek ljubazno, stručni treneri su tu za pomoć i motivaciju, a atmosfera je toliko pozitivna da je svaki dolazak ugodan i motivirajuć. Muške i ženske svlačionice imaju svaka svoj wc i tuš. Uvijek čisto i mirisno.
                     Preporučam svima koji traže kvalitetan fitness centar sa mnoštvom opreme, sprava, savjeta i pomoći u Baranji :)',
		'date'   => 'Prije godinu dana',
	),
	array(
		'author' => 'Sara D.',
		'rating' => 5,
		'text'   => 'Odličan gym koji radi 0–24, što je ogroman plus jer mogu trenirati kad god mi odgovara. Oprema je super i sve je uredno. Djelatnici su stvarno super uvijek ljubazni, pristupačni i spremni pomoći oko bilo čega. Preporučujem svima koji traže kvalitetno mjesto za trening bez stresa',
		'date'   => 'Prije 4 mjesca',
	),
);

if ( empty( $reviews ) ) {
	return;
}
?>

<section class="py-10 md:py-25 bg-white">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="text-center mb-12">
			<div class="flex items-center justify-center gap-2 mb-4">
				<!-- Google "G" icon -->
				<svg class="w-8 h-8" viewBox="0 0 24 24" fill="none">
					<path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" fill="#4285F4"/>
					<path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
					<path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
					<path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
				</svg>
				<h2 class="text-3xl font-bold text-gray-900"><?php esc_html_e( 'Google Reviews', 'bmfitness' ); ?></h2>
			</div>
			<div class="flex items-center justify-center gap-1 text-yellow-400 text-2xl mb-2">
				★★★★★
			</div>
			<p class="text-gray-500 text-sm"><?php esc_html_e( 'Pogledajte što su rekli neki naši posjetitelji', 'bmfitness' ); ?></p>
		</div>

		<div class="grid gap-6 md:grid-cols-3" id="google-reviews">
			<?php foreach ( $reviews as $review ) : ?>
				<div class="bg-gray-50 rounded-xl p-6 border border-gray-100">
					<div class="flex items-center gap-3 mb-4">
						<div class="w-10 h-10 bg-brand-600 text-white rounded-full flex items-center justify-center font-semibold text-sm">
							<?php echo esc_html( mb_substr( $review['author'], 0, 1 ) ); ?>
						</div>
						<div>
							<p class="font-semibold text-gray-900 text-sm"><?php echo esc_html( $review['author'] ); ?></p>
							<p class="text-gray-400 text-xs"><?php echo esc_html( $review['date'] ); ?></p>
						</div>
					</div>
					<div class="flex gap-0.5 text-yellow-400 text-sm mb-3">
						<?php echo str_repeat( '★', $review['rating'] ); ?>
						<?php echo str_repeat( '☆', 5 - $review['rating'] ); ?>
					</div>
					<p class="text-gray-700 text-sm leading-relaxed"><?php echo esc_html( $review['text'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="text-center mt-8">
			<a href="<?php echo esc_url( $google_reviews_url ); ?>"
			   target="_blank"
			   rel="noopener noreferrer"
			   class="inline-flex items-center gap-2 text-brand-600 font-semibold hover:text-brand-700 transition-colors">
				<?php esc_html_e( 'Pogledajte ostale recenzije →', 'bmfitness' ); ?>
			</a>
		</div>
	</div>
</section>
