<style>
/* Horizontal Scrollable Panel */
.horizontal-scroll-container {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none; /* Firefox */
    overflow-y: visible !important;
    display: flex;
    align-items: center;
    justify-content: center;
}

.horizontal-scroll-container::-webkit-scrollbar {
    display: none; /* Chrome, Safari, Edge */
}

.scroll-wrapper {
    display: flex;
    flex-wrap: nowrap;
    padding-top:  1rem;
    justify-content: center; /* Center the buttons */
    overflow: visible !important;
    align-items: center;
}

.scroll-item {
    flex: 0 0 auto;
    margin-right: 1rem;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    background-color: var(--card-bg);
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
    white-space: nowrap;
    position: relative;
}

.scroll-item a {
    color: var(--text-color);
    text-decoration: none;
    font-size: 18px; /* Increased font size for category titles */
    font-weight: 500; /* Added some weight to make it more prominent */
}

.scroll-item.active {
    background-color: var(--primary-color);
}

.scroll-item.active a {
    color: white;
}

.scroll-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

/* Custom dropdown styles */
.custom-dropdown-menu {
    display: none;
    position: fixed;
    z-index: 9999;
    /* min-width: 200px; */
    padding: 0.5rem 0;
    margin: 0.5rem 0 0;
    background-color: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 0.5rem;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transform: translateX(0px) translateY(5px);
}

.custom-dropdown-item {
    display: block;
    width: 100%;
    padding: 0.5rem 1rem;
    clear: both;
    text-align: center;
    white-space: nowrap;
    color: var(--text-color);
    background-color: transparent;
    border: 0;
    transition: all 0.2s ease;
    font-size: 18px; /* Increased font size for subcategory */
    text-decoration: none; /* Remove underline from links */
    line-height: 1.5; /* Improve line height */
}

.custom-dropdown-item:hover {
    background-color: var(--primary-color);
    color: white;
    text-decoration: none; /* Ensure no underline on hover */
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .scroll-item {
        padding: 0.4rem 0.8rem;
        font-size: 0.9rem;
        margin-right: 0.5rem; /* Smaller margin on mobile */
    }
    .scroll-wrapper {
        justify-content: flex-start; /* Left align on mobile */
        padding-left: 1rem; /* Add padding only on mobile */
    }
    
    .custom-dropdown-menu {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        width: 100%;
        max-height: 50vh;
        overflow-y: auto;
        border-radius: 1rem 1rem 0 0;
        box-shadow: 0 -4px 10px rgba(0,0,0,0.1);
        margin: 0;
        transform: none;
        padding-top: 1rem;
        padding-bottom: 1rem;
    }
    
    .custom-dropdown-item {
        padding: 0.75rem 1rem;
        font-size: 18px;
        font-weight: 400;
    }
    .scroll-item a {
        font-size: 16px; /* Adjusted font size for mobile category titles */
    }
    
    .dropdown-backdrop {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0,0,0,0.5);
        z-index: 1040;
    }
    
    .dropdown-backdrop.show {
        display: block;
    }
}

/* Add dropdown indicator */
.dropdown-toggle::after {
    display: inline-block;
    margin-left: 0.255em;
    vertical-align: 0.255em;
    content: "";
    border-top: 0.3em solid;
    border-right: 0.3em solid transparent;
    border-bottom: 0;
    border-left: 0.3em solid transparent;
}
</style>

<div class="horizontal-scroll-container mb-4">
    <div class="scroll-wrapper">        
        @php
            $categories = DB::table('categories')->get();
        @endphp
        
        @foreach ($categories as $category)
            @php
                $subcategories = DB::table('cate_sub_cate_rels')
                    ->join('sub_categories', 'sub_categories.sub_category_code', '=', 'cate_sub_cate_rels.sub_category_code')
                    ->where('cate_sub_cate_rels.category_code', $category->category_code)
                    ->select('sub_categories.*')
                    ->get();
            @endphp
            
            
        @endforeach
    </div>
</div>

<!-- Dropdown menus outside the scroll container -->
@foreach ($categories as $category)
    @php
        $subcategories = DB::table('cate_sub_cate_rels')
            ->join('sub_categories', 'sub_categories.sub_category_code', '=', 'cate_sub_cate_rels.sub_category_code')
            ->where('cate_sub_cate_rels.category_code', $category->category_code)
            ->select('sub_categories.*')
            ->get();
    @endphp
    
    <!--  -->
@endforeach

<div class="dropdown-backdrop"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    const backdrop = document.querySelector('.dropdown-backdrop');
    let isMobile = window.innerWidth < 768;
    
    // Handle dropdown toggle clicks
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const categoryCode = this.getAttribute('data-category');
            const dropdown = document.getElementById('dropdown-' + categoryCode);
            
            // Close all other dropdowns first
            document.querySelectorAll('.custom-dropdown-menu').forEach(el => {
                if (el.id !== 'dropdown-' + categoryCode) {
                    el.style.display = 'none';
                }
            });
            
            // Toggle current dropdown
            if (dropdown.style.display === 'block') {
                dropdown.style.display = 'none';
                if (isMobile) {
                    backdrop.classList.remove('show');
                    document.body.style.overflow = '';
                }
            } else {
             // Position the dropdown relative to the toggle button
            const rect = this.getBoundingClientRect();

            if (!isMobile) {
                // Calculate center position of the button
                const buttonCenter = rect.left + (rect.width / 2);
                
                // Get dropdown width (after making it temporarily visible)
                dropdown.style.visibility = 'hidden';
                dropdown.style.display = 'block';
                const dropdownWidth = dropdown.offsetWidth;
                
                // Position dropdown centered under the button
                dropdown.style.top = (rect.bottom + window.scrollY + 5) + 'px';
                dropdown.style.left = (buttonCenter - (dropdownWidth / 2) + window.scrollX) + 'px';
                dropdown.style.visibility = 'visible';
            } else {
                dropdown.style.display = 'block';
            }                
                if (isMobile) {
                    backdrop.classList.add('show');
                    document.body.style.overflow = 'hidden';
                }
            }
        });
    });
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.scroll-item') && !e.target.closest('.custom-dropdown-menu')) {
            document.querySelectorAll('.custom-dropdown-menu').forEach(dropdown => {
                dropdown.style.display = 'none';
            });
            
            if (isMobile) {
                backdrop.classList.remove('show');
                document.body.style.overflow = '';
            }
        }
    });
    
    // Close dropdown when clicking backdrop on mobile
    backdrop.addEventListener('click', function() {
        document.querySelectorAll('.custom-dropdown-menu').forEach(dropdown => {
            dropdown.style.display = 'none';
        });
        
        backdrop.classList.remove('show');
        document.body.style.overflow = '';
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        const newIsMobile = window.innerWidth < 768;
        
        if (newIsMobile !== isMobile) {
            isMobile = newIsMobile;
            // Close all dropdowns on breakpoint change
            document.querySelectorAll('.custom-dropdown-menu').forEach(dropdown => {
                dropdown.style.display = 'none';
            });
            
            backdrop.classList.remove('show');
            document.body.style.overflow = '';
        }
    });
});
</script>