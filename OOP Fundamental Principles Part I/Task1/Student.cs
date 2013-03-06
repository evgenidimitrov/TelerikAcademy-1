using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace Task1
{
    class Student : Person, ICommentable
    {
        public string ClassNumber { get; set; }

        public Student(string name, string classNumber)
        {
            this.Name = name;
            this.ClassNumber = classNumber;
        }

        public List<string> Comments { get; set; }

        public void AddComment(string comment)
        {
            Comments.Add(comment);
        }
    }
}
