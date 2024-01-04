                <div class="footer">
                    <p class="m-0">©xxx</p>
                </div>
            </div><!-- .container -->
        </div>
<script>
	$( document ).ready(function() {
		if ($(window).width() < 991) {
			$( ".cross" ).hide();
			$( ".top--menu" ).hide();
			$( ".hamburger" ).click(function() {
				$('.logo').css('visibility', 'hidden');
				$(".top--menu").appendTo("#top--nav");
				$( ".top--menu" ).slideToggle( "slow", function() {
					$( ".hamburger" ).hide();
					$( ".cross" ).show();
				});
			});

			$( ".cross" ).click(function() {
				$( ".top--menu" ).slideToggle( "slow", function() {
					$( ".cross" ).hide();
					$( ".hamburger" ).show();
					$('.logo').css('visibility', 'visible');
					
				});
			});
		} else {
			$( ".top--menu" ).show();
		}

	});

	$(window).on('resize',function() {
        if ($(window).width() > 1023) {
            $('.top--menu').show();
        } else {
            $('.top--menu').hide();
            $('.cross').hide();
        }
    });

</script>
    </body>
</html>