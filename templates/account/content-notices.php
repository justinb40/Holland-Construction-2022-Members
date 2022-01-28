<?php

if ( !property_exists($notices, 'scalar') ): ?>

    <?php

    // echo '<pre>';
    // print_r($notices);
    // echo '</pre>';

    ?>

    <div class="b40-notices">
    
        <?php foreach ($notices as $key => $messages): ?>

                <?php if (count($messages)): ?>

                <div class="b40-notice <?php echo $key; ?>">
                    <ul>
                        <?php foreach ($messages as $message): ?>

                        <li><?php echo $message; ?></li>

                        <?php endforeach; ?>
                    </ul>
                </div>

                <?php endif; ?>

        <?php endforeach; ?>

    </div>

<?php
endif;