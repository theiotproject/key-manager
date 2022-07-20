<template>
    <div class="p-3">
        <label for="input-group-search" class="sr-only">Search</label>
        <div class="relative">
            <div
                class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none"
            >
                <svg
                    class="w-5 h-5 text-gray-500 dark:text-gray-400"
                    aria-hidden="true"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        fill-rule="evenodd"
                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                        clip-rule="evenodd"
                    ></path>
                </svg>
            </div>
            <input
                type="text"
                id="input-group-search"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Search user"
            />
        </div>
    </div>
    <ul
        class="overflow-y-auto px-3 pb-3 h-48 text-sm text-gray-700 dark:text-gray-200"
        aria-labelledby="dropdownSearchButton"
    >
        <li>
            <div
                class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600"
            >
                <input
                    id="checkbox-item-11"
                    type="checkbox"
                    value=""
                    class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                />
                <label
                    for="checkbox-item-11"
                    class="ml-2 w-full text-sm font-medium text-gray-900 rounded dark:text-gray-300"
                    >Bonnie Green</label
                >
            </div>
        </li>
        <li>
            <div
                class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600"
            >
                <input
                    checked="true"
                    id="checkbox-item-12"
                    type="checkbox"
                    value=""
                    class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                />
                <label
                    for="checkbox-item-12"
                    class="ml-2 w-full text-sm font-medium text-gray-900 rounded dark:text-gray-300"
                    >Jese Leos</label
                >
            </div>
        </li>
        <li>
            <div
                class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600"
            >
                <input
                    id="checkbox-item-13"
                    type="checkbox"
                    value=""
                    class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                />
                <label
                    for="checkbox-item-13"
                    class="ml-2 w-full text-sm font-medium text-gray-900 rounded dark:text-gray-300"
                    >Michael Gough</label
                >
            </div>
        </li>
        <li>
            <div
                class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600"
            >
                <input
                    id="checkbox-item-14"
                    type="checkbox"
                    value=""
                    class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                />
                <label
                    for="checkbox-item-14"
                    class="ml-2 w-full text-sm font-medium text-gray-900 rounded dark:text-gray-300"
                    >Robert Wall</label
                >
            </div>
        </li>
        <li>
            <div
                class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600"
            >
                <input
                    id="checkbox-item-15"
                    type="checkbox"
                    value=""
                    class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                />
                <label
                    for="checkbox-item-15"
                    class="ml-2 w-full text-sm font-medium text-gray-900 rounded dark:text-gray-300"
                    >Joseph Mcfall</label
                >
            </div>
        </li>
        <li>
            <div
                class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600"
            >
                <input
                    id="checkbox-item-16"
                    type="checkbox"
                    value=""
                    class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                />
                <label
                    for="checkbox-item-16"
                    class="ml-2 w-full text-sm font-medium text-gray-900 rounded dark:text-gray-300"
                    >Leslie Livingston</label
                >
            </div>
        </li>
        <li>
            <div
                class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600"
            >
                <input
                    id="checkbox-item-17"
                    type="checkbox"
                    value=""
                    class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                />
                <label
                    for="checkbox-item-17"
                    class="ml-2 w-full text-sm font-medium text-gray-900 rounded dark:text-gray-300"
                    >Roberta Casas</label
                >
            </div>
        </li>
    </ul>
</template>
